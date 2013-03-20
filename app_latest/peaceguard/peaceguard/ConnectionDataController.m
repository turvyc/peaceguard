//
//  ConnectionDataController.m
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-03-02.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "ConnectionDataController.h"

@implementation ConnectionDataController

//Sends a POST request to the server and receives a JSON
- (NSDictionary *) sendRequestWithURL:(NSString *)url andData:(NSString *)post{
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
    NSDictionary *jsonDictionary = [self sendRequestWithURL:@"http://peaceguard.dyndns.org:1728/control/login.control.php" andData:post];
    
    BOOL success = [[jsonDictionary objectForKey:@"successful"] boolValue];
    
    if(success){
        NSLog(@"Successful!!!");
    }
    else{
        success = NO;
    }
    
    return success;
}

//Sends a report to the server
- (void) reportWithPostData: (NSString *) data{
    
    NSString *post = data;
    NSDictionary *jsonDictionary = [self sendRequestWithURL:@"http://peaceguard.dyndns.org:1728/control/report.control.php" andData:post];
    
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
- (void) endAndSendPatrolID: (NSInteger) patrolID duration: (NSInteger) duration route: (NSString *) route distance: (double) distance {
    
    NSString *post = [NSString stringWithFormat:@"patrol=%i&duration=%i&route=%@&distance=%f&agent=iphone", patrolID, duration, route, distance];
    NSDictionary *jsonDictionary = [self sendRequestWithURL:@"http://peaceguard.dyndns.org:1728/control/endpatrol.control.php" andData:post];

    
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
    NSDictionary *jsonDictionary = [self sendRequestWithURL:@"http://peaceguard.dyndns.org:1728/control/beginpatrol.control.php" andData:post];

    
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
    NSDictionary *jsonDictionary = [self sendRequestWithURL:@"http://peaceguard.dyndns.org:1728/control/patrolstats.control.php" andData:post];
    
    
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

@end
