//
//  UserDataController.m
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-02-15.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "UserDataController.h"
#import "User.h"

@interface UserDataController ()

- (void) initializeDefaultUser;

@end

@implementation UserDataController

- (void) initializeDefaultUser
{
    self.currentUser = [[User alloc]initWithUsername:nil password: nil];
  
}

- (BOOL)authenticateUser:(User *)theUser{
    //POST code below by Robbie Hanson @
    //http://deusty.blogspot.ca/2006/11/sending-http-get-and-post-from-cocoa.html
    //With modifications by Ashley Lesperance
    
    NSString *post = @"email=";
    post = [post stringByAppendingString:self.currentUser.username];
    post = [post stringByAppendingString:@"&password="];
    post = [post stringByAppendingString:self.currentUser.password];
    post = [post stringByAppendingString:@"&agent=iphone"];
    
    NSData *postData = [post dataUsingEncoding:NSASCIIStringEncoding allowLossyConversion:YES];
    
    NSString *postLength = [NSString stringWithFormat:@"%d", [postData length]];
    
    NSMutableURLRequest *request = [[NSMutableURLRequest alloc] init];
    [request setURL:[NSURL URLWithString:@"http://peaceguard.dyndns.org:1728/control/login.control.php"]];
    [request setHTTPMethod:@"POST"];
    [request setValue:postLength forHTTPHeaderField:@"Content-Length"];
    [request setValue:@"application/x-www-form-urlencoded" forHTTPHeaderField:@"Content-Type"];
    [request setHTTPBody:postData];
    //End of POST
    
    //Receive JSON
    NSURLResponse *response;
    NSError *err;
    NSData *responseData = [NSURLConnection sendSynchronousRequest:request returningResponse:&response error:&err];
    
    //JSON processing
    NSError *error;
    NSDictionary *jsonDictionary = [NSJSONSerialization JSONObjectWithData:responseData options:NSJSONReadingMutableContainers error:&error];
    if (! error) {
        NSLog(@"%@",jsonDictionary);
    }else{
        NSLog(@"%@",error.localizedDescription);
    }
    
    NSString *success = [jsonDictionary objectForKey:@"succesful"];
    
    if([success isEqualToString:@"yes"]){
        return YES;
    }
    else{
        return NO;
    }


}

- (void)logUsername: (NSString *) username andPassword: (NSString *) password{
    
    self.currentUser.username = username;
    self.currentUser.password = password;
    
}

@end
