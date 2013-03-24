//
//  ConnectionDataController.m
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-03-02.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "ConnectionDataController.h"

@implementation ConnectionDataController

NSString *serverAddress = @"http://peaceguard.dyndns.org:1728/peaceguard-test";

//Sends a POST request to the server and receives a JSON
- (NSDictionary *) sendRequestWithURL:(NSString *)url andData:(NSString *)post{
    // Test if internet connection is available
    // If not possible send error
    if (![self connectionAvailable]) {
        NSNumber *successful = [NSNumber numberWithBool:NO];
        NSArray *keys = [NSArray arrayWithObjects:@"successful", @"message", nil];
        NSArray *objects = [NSArray arrayWithObjects:successful, @"noConnection", nil];
        //NSDictionary   *retVal = [NSDictionary dictionaryWithObject: successful forKey: @"successful"];
        NSDictionary *retVal = [NSDictionary dictionaryWithObjects:objects forKeys:keys];
        
        //Let the user know
        UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Connection Failed"
                                                        message:@"You are not currently connected to the internet"
                                                       delegate:nil
                                              cancelButtonTitle:@"OK"
                                              otherButtonTitles:nil];
        [alert show];
        
        return retVal;
    }
    //Test if connection to server is possible
    //    if (![self serverAvailable]) {
    //        NSNumber *successful = [NSNumber numberWithBool:NO];
    //        NSDictionary   *retVal = [NSDictionary dictionaryWithObject: successful forKey: @"successful"];
    //        return retVal;
    //    }
    
    NSLog(@"Data: %@",post);
    
    NSData *postData = [post dataUsingEncoding:NSASCIIStringEncoding allowLossyConversion:YES];
    
    NSString *postLength = [NSString stringWithFormat:@"%d", [postData length]];
    
    NSMutableURLRequest *request = [[NSMutableURLRequest alloc] init];
    
    [request setURL:[NSURL URLWithString:url]];
    [request setHTTPMethod:@"POST"];
    [request setValue:postLength forHTTPHeaderField:@"Content-Length"];
    [request setValue:@"application/x-www-form-urlencoded" forHTTPHeaderField:@"Content-Type"];
    [request setHTTPBody:postData];
    NSLog(@"Data: %@",request);
    //End of POST
    
    //Receive JSON
    NSURLResponse *response;
    NSError *err;
    NSData *responseData = [NSURLConnection sendSynchronousRequest:request returningResponse:&response error:&err];
    NSLog(@"Data: %@",responseData);
    NSString *responseString = [[NSString alloc] initWithData:responseData encoding:NSASCIIStringEncoding];
    NSLog(@"Data: %@", responseString);
    
    //JSON processing
    NSError *error;
    NSDictionary *jsonDictionary = [NSJSONSerialization JSONObjectWithData:responseData options:NSJSONReadingMutableContainers error:&error];
    if (! error) {
        NSLog(@"%@",jsonDictionary);
    }else{
        NSLog(@"%@",error.localizedDescription);
    }
    
    NSLog(@"JSON: %@", jsonDictionary);
    return jsonDictionary;
    
}

//Use the users email and password to login
- (BOOL) serverLoginWithEmail:(NSString *)email andPassword:(NSString *)password{
    
    NSString *post = [NSString stringWithFormat:@"email=%@&password=%@&agent=iphone", email, password];
    NSString *url = [NSString stringWithFormat:@"%@/control/login.control.php", serverAddress];
    NSDictionary *jsonDictionary = [self sendRequestWithURL:url andData:post];
    
    BOOL success = [[jsonDictionary objectForKey:@"successful"] boolValue];
    
    if(success){
        NSLog(@"Successful!!!");
    }
    else if ([[jsonDictionary objectForKey:@"message"] isEqualToString:@"noConnection"]){
        success = NO;
    }
    else{
        success = NO;
        //Let the user know the login failed
        UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Login Failed"
                                                        message:@"The username or password was incorrect."
                                                       delegate:nil
                                              cancelButtonTitle:@"OK"
                                              otherButtonTitles:nil];
        [alert show];
    }
    
    return success;
}

//Sends a report to the server
- (void) reportWithPostData: (NSString *) data{
    
    NSString *post = data;
    NSString *url = [NSString stringWithFormat:@"%@/control/report.control.php", serverAddress];
    NSDictionary *jsonDictionary = [self sendRequestWithURL:url andData:post];
    
    BOOL success = [[jsonDictionary objectForKey:@"successful"] boolValue];
    
    NSString *test = @"done";
    if(success){
        NSLog(@"Successful!!!");
        test = @"Succesful";
    }
    else{
        success = NO;
        test = @"failed";
    }
    
    
}

//Sends end of patrol information to server
- (void) endAndSendPatrolID: (NSInteger) patrolID duration: (NSInteger) duration route: (NSString *) route distance: (double) distance email: (NSString *) email{
    
    NSString *post = [NSString stringWithFormat:@"patrol=%i&duration=%i&route=%@&distance=%f&agent=iphone&email=%@", patrolID, duration, route, distance,email];
    NSString *url = [NSString stringWithFormat:@"%@/control/endpatrol.control.php", serverAddress];
    NSDictionary *jsonDictionary = [self sendRequestWithURL:url andData:post];
    
    
    BOOL success = [[jsonDictionary objectForKey:@"successful"] boolValue];
    
    if(success){
        NSLog(@"Successful!!!");
    }
    else{
        success = NO;
        NSLog(@"NOT Successful");
    }
    
    
}

//Sends the start patrol information to server and receives patrolID
- (NSInteger) startPatrolWithEmail: (NSString *) email{
    
    NSDate *currDate = [NSDate date];
    NSInteger currentUnixTime = [currDate timeIntervalSince1970];
    
    NSString *post = [NSString stringWithFormat:@"email=%@&startTime=%i&agent=iphone", email, currentUnixTime];
    NSString *url = [NSString stringWithFormat:@"%@/control/beginpatrol.control.php", serverAddress];
    NSDictionary *jsonDictionary = [self sendRequestWithURL:url andData:post];
    
    
    BOOL success = [[jsonDictionary objectForKey:@"successful"] boolValue];
    
    if(success){
        NSLog(@"Successful!!!");
    }
    else{
        success = NO;
        NSLog(@"NOT Successful");
    }
    return [[jsonDictionary objectForKey:@"patrol"] integerValue];
}

//Requests user statistics from a specified time period from the server
- (NSDictionary *) getStatistics: (NSString *) email andTimePeriod: (NSString *) timePeriod{
    
    NSString *post = [NSString stringWithFormat:@"email=%@&timePeriod=%@&agent=iphone", email, timePeriod];
    NSString *url = [NSString stringWithFormat:@"%@/control/patrolstats.control.php", serverAddress];
    NSDictionary *jsonDictionary = [self sendRequestWithURL:url andData:post];
    
    
    BOOL success = [[jsonDictionary objectForKey:@"successful"] boolValue];
    
    NSString *test = @"done";
    if(success){
        NSLog(@"Successful!!!");
        test = @"Succesful";
    }
    else{
        success = NO;
        test = @"failed";
    }
    return jsonDictionary;
}

//Requests user badges from the server
- (NSDictionary *) getBadge: (NSString *) email andTimePeriod: (NSString *) timePeriod{
    
    NSString *post = [NSString stringWithFormat:@"email=%@&timePeriod=%@&agent=iphone", email, timePeriod];
    NSString *url = [NSString stringWithFormat:@"%@/control/getbadges.control.php", serverAddress];
    NSDictionary *jsonDictionary = [self sendRequestWithURL:url andData:post];
    
    
    BOOL success = [[jsonDictionary objectForKey:@"successful"] boolValue];
    
    NSString *test = @"done";
    if(success){
        NSLog(@"Successful Badge!!!");
        test = @"Succesful";
    }
    else{
        success = NO;
        test = @"failed";
    }
    return jsonDictionary;
}

//Check whether the internet connection is available
- (BOOL) connectionAvailable{
    Reachability *reachability = [Reachability reachabilityForInternetConnection];
    NetworkStatus internetStatus = [reachability currentReachabilityStatus];
    if (internetStatus != NotReachable){
        return YES;
    }
    else{
        return NO;
    }
}

//Check whether the server is available [Not working/ Not required]
//
//
//- (BOOL) serverAvailable{
//    Reachability *reachability = [Reachability reachabilityWithHostname:serverAddress];
//    NetworkStatus internetStatus = [reachability currentReachabilityStatus];
//    if (internetStatus != NotReachable){
//        return YES;
//    }
//    else{
//        return NO;
//    }
//
//}




@end
