//
//  Report.m
//
//  Contributor(s): Ashley Lesperance, Jonas Yao
//
//  Copyright (c) 2013 Number 123 Developer's Group
//


#import "Report.h"

@implementation Report

-(id) initWithType: (NSString *) type severity: (NSString *) severity location: (NSString *) location time: (NSInteger *) time andDescription: (NSString *) description{
    self = [super init];
    if(self) {
        _type = type;
        _severity = severity;
        _location = location;
        _time = time;
        _description = description;
        return self;
    }
    
    return nil;
    
}
@end
